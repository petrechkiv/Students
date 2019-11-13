<?php

namespace app\controllers;

use app\models\Lessons;
use app\models\LessonsSearch;
use app\models\Predmets;
use Yii;
use app\models\Users;
use app\models\UsersSearch;
use yii\bootstrap\Collapse;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Groups;
use yii\widgets\DetailView;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class StudentsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role !== 'teacher') {
            $this->redirect('/lessons/index');
        }

        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('role = "student"');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'groups' => $this->getGroups(),
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $group = Groups::findOne($model->group_id);

        $model->group_id = $group->caption;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionStatistic($id)
    {
        $model = $this->findModel($id);

        $lessons = Lessons::findAll(['student_id' => $model->id]);

        $teachers = $this->getTeachers();

        $countVisit = [];
        foreach ($lessons as $lesson) {
            $searchModel = new LessonsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere('predmet_id = ' . $lesson['predmet_id']);
            $dataProvider->query->andWhere('student_id = ' . $model->id);
            $dataProvider->query->addOrderBy('date');
            $groupLessons[$lesson['predmet_id']] = GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'teacher_id',
                        'format' => 'raw',
                        'value' => function ($model) use ($teachers) {
                            return $teachers[$model->teacher_id];
                        }
                    ],
                    'date',
                    [
                        'attribute' => 'visit',
                        'label' => 'Визит',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->visit ? '<i style="font-size: 20px; color: green;" class="glyphicon glyphicon-ok-circle"></i>' : '<i style="font-size: 20px; color: red;" class="glyphicon glyphicon-remove-circle fa-lg"></i>';

                        }
                    ],
                ],
            ]);

            if ($lesson['visit']) {
                $countVisit[$lesson['predmet_id']]['visit']++;
            } else {
                $countVisit[$lesson['predmet_id']]['not_visit']++;
            }
        }

        $group = Groups::findOne($model->group_id);
        $model->group_id = $group->caption;

        $predmetIds = array_unique(array_column($lessons, 'predmet_id'));
        $predmets = Predmets::findAll($predmetIds);

        foreach ($predmets as $i => $predmet) {
            $newPredmets[$predmet['id']] = [
                'id' => $predmet['id'],
                'caption' => $predmet['caption'],
                'info' => [
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'Количество часов',
                                'value' => $predmet['count_hours'],
                            ],
                            [
                                'label' => 'Сколько часов студент посетил',
                                'value' => $countVisit[$predmet['id']]['visit'],
                            ],
                            [
                                'label' => 'Сколько часов студент пропустил',
                                'value' => !empty($countVisit[$predmet['id']]['not_visit']) ? $countVisit[$predmet['id']]['not_visit'] : 0,
                            ]
                        ],
                    ]) . Collapse::widget([
                        'items' => [
                            [
                                'label' => 'Посмотреть визиты студента',
                                'content' => $groupLessons[$predmet['id']],
                                'contentOptions' => [],
                                'options' => [],
                            ],
                        ]
                    ]),
                ],
            ];
        }

        return $this->render('statistic', [
            'model' => $model,
            'predmets' => $newPredmets,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'groups' => $this->getGroups(),
        ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'groups' => $this->getGroups(),
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function getGroups()
    {

        $result = array();

        $model = Groups::find()
            ->all();

        foreach ($model as $record) {
            $result[$record['id']] = $record['caption'];
        }

        return $result;
    }

    private function getTeachers()
    {

        $result = array();

        $model = Users::findAll(['role' => 'teacher']);
        foreach ($model as $record) {
            $result[$record['id']] = $record['fio'];
        }

        return $result;
    }
}
