<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\Category;
use app\models\Coments;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /** @var Post $data */
        $data = Post::find()
            ->where(['id' => $id])
            ->one();
        $cat = $data->categories;
        $postComents = ArrayHelper::getColumn( $data->comments, 'description');
        $comentStr = "";
        foreach($postComents as $value) {
            $comentStr.= "<p>".$value."</p><hr>";
        }


        print_r($postComents);

        $string = "";
        foreach($cat as $value) {
            $string.=  Html::a($value->name, ['category/view', 'id' => $value->id]);
            $string.='<br>';
        }

        $coment = new Coments();
        if ($coment->load(Yii::$app->request->post())) {
            $coment->post_id = $id;
            $coment->save();
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'string' => $string,
            'coment' => $coment,
            'comentStr' => $comentStr
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        if ($model->load(Yii::$app->request->post())) {
            $model->createad_at = time();
            $model->save();

            $data = Category::find()
                ->where(['id' => $model->categoriesId])
            ->all();

            foreach($data as $category) {
                $category->link('posts', $model);

            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        /** @var Post $data */

        $model->categoriesId = ArrayHelper::getColumn( $model->categories, 'id');

        if ($model->load(Yii::$app->request->post())) {
            $data = Category::find()
                ->where(['id' => $model->categoriesId])
                ->all();
            $model->unlinkAll('categories', true);
            foreach($data as $category) {
                $category->link('posts', $model);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->unlinkAll('categories', true);
        $model->delete();


        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}