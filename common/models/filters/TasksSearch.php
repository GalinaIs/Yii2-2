<?php

namespace common\models\filters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\tables\Tasks;

/**
 * TasksSearch represents the model behind the search form of `app\models\tables\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'responsible_id', 'project_id', 'id_status', 'create_user_id'], 'integer'],
            [['name', 'date', 'description', 'execution_date'], 'safe'],
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
    public function search($params, $idProject = null)
    {
        if ($idProject) {
            $query = Tasks::find()
                ->where(['project_id' => $idProject]);
        } else {
            $query = Tasks::find();
        }
    
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
            'date' => $this->date,
            'execution_date' => $this->execution_date,
            'responsible_id' => $this->responsible_id,
            'id_status' => $this->id_status,
            'project_id' => $this->project_id,
            'create_user_id' => $this->create_user_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
