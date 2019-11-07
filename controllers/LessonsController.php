<?php

namespace app\controllers;

use Yii;
use app\models\Lessons;
use app\models\LessonsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Users;
use app\models\Predmets;

/**
 * LessonsController implements the CRUD actions for Lessons model.
 */
class LessonsController extends Controller
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
     * Lists all Lessons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LessonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->user->identity->role === 'student') {
            $dataProvider->query->andWhere('student_id = ' . Yii::$app->user->getId());
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'teachers' => $this->getTeachers(),
            'students' => $this->getStudents(),
            'predmets' => $this->getPredmets(),
            'is_teacher' => Yii::$app->user->identity->role === 'teacher' ? true : false,
        ]);
    }

    /**
     * Displays a single Lessons model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $student = Users::findOne($model->student_id);
        $teacher = Users::findOne($model->teacher_id);
        $predmet = Predmets::findOne($model->predmet_id);

        $model->student_id = $student->fio;
        $model->teacher_id = $teacher->fio;
        $model->predmet_id = $predmet->caption;
        $model->date = date('d.m.Y', strtotime($model->date));
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Lessons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lessons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'teachers' => $this->getTeachers(),
            'students' => $this->getStudents(),
            'predmets' => $this->getPredmets(),
        ]);
    }

    /**
     * Updates an existing Lessons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $predmet = Predmets::findOne($model->predmet_id);
        $predmet = $predmet->caption;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'teachers' => $this->getTeachers(),
            'students' => $this->getStudents(),
            'predmets' => $this->getPredmets(),
            'predmet' => $predmet,
        ]);
    }

    /**
     * Deletes an existing Lessons model.
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
     * Finds the Lessons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lessons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lessons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

    private function getStudents()
    {

        $result = array();

        $model = Users::findAll(['role' => 'student']);
        foreach ($model as $record) {
            $result[$record['id']] = $record['fio'];
        }

        return $result;
    }

    private function getPredmets()
    {

        $result = array();

        $model = Predmets::find()
            ->all();
        foreach ($model as $record) {
            $result[$record['id']] = $record['caption'];
        }

        return $result;
    }
}
