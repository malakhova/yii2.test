<?php

namespace frontend\forms;

use common\essences\Comment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommentSearch represents the model behind the search form of `backend\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'post_id', 'parent_id', 'level'], 'integer'],
            [['comment', 'created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find()
            ->with(['user'])
            ->with(['post'])
            ->with(['parent'])
            ->with(['parent.user']);

        // add conditions that should always apply here

//        $treeQuery = array();
//        foreach ($query as $comment){
//            if(!$comment->parent->id){
//                $treeQuery[] = $comment;
//                foreach ($query as $innerComment){
//                    if($comment->id == $innerComment->parent_id){
//                        $treeQuery[] = $innerComment;
//                    }
//                }
//            }
//        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'post_id' => $this->post_id,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
