<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\essences\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\essences\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'category_id', 'bill_id'], 'integer'],
            [['money'], 'number'],
            [['created_at'], 'safe'],
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
        $query = Transaction::find();
        $query->andFilterWhere(['user_id' => Yii::$app->user->id]);

        // add conditions that should always apply here

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
            'type' => $this->type,
            'category_id' => $this->category_id,
            'bill_id' => $this->bill_id,
            'money' => $this->money,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
