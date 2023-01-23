<?php

namespace meliorator\cron\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CronJobRunSearch represents the model behind the search form of `\meliorator\cron\models\CronJobRun`.
 */
class CronJobRunSearch extends CronJobRun
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'job_id', 'in_progress', 'exit_code'], 'integer'],
            [['pid', 'start', 'finish', 'output', 'error_output'], 'safe'],
            [['runtime'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = CronJobRun::find();

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

        $query->andFilterWhere(['AND',
            ['id' => $this->id],
            ['job_id' => $this->job_id],
            ['like', 'pid', $this->pid],
            ['runtime' => $this->runtime],
            ['exit_code' => $this->exit_code],
            ['like', 'output', $this->output],
            ['like', 'error_output', $this->error_output],
        ]);

        if (is_numeric($this->in_progress) || is_bool($this->in_progress)) {
            $query->where(['in_progress' => (bool)$this->in_progress]);
        }

        if ($this->start) {
            if (strpos($this->start, ' ') === false) {
                $query->andWhere(['AND',
                    ['>=', 'start', $this->start . ' 00:00:00'],
                    ['<=', 'start', $this->start . ' 23:59:59'],
                ]);
            } else {
                $query->andWhere(['start', $this->start]);
            }
        }

        if ($this->finish) {
            if (strpos($this->finish, ' ') === false) {
                $query->andWhere(['AND',
                    ['>=', 'finish', $this->finish . ' 00:00:00'],
                    ['<=', 'finish', $this->finish . ' 23:59:59'],
                ]);
            } else {
                $query->andWhere(['finish', $this->finish]);
            }
        }

        return $dataProvider;
    }

}
