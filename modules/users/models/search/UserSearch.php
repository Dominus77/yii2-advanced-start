<?php

namespace modules\users\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\users\models\User;

/**
 * Class UserSearch
 * @package modules\users\models\backend
 *
 * @property string $userRoleName User Role Name
 * @property string $date_from Date From
 * @property string $date_to Date To
 * @property integer $pageSize Page Size
 */
class UserSearch extends User
{
    public $userRoleName;
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'role', 'userRoleName', 'date_from', 'date_to'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @return \modules\users\models\query\UserQuery
     */
    protected function getQuery()
    {
        $query = User::find();
        $query->innerJoinWith('profile', 'profile.user_id = id');
        $query->leftJoin('{{%auth_assignment}}', '{{%auth_assignment}}.user_id = {{%user}}.id');
        return $query;
    }

    /**
     * @param \yii\db\ActiveQuery $query
     * @return ActiveDataProvider
     */
    protected function getDataProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 25
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
                'attributes' => [
                    'id',
                    'username',
                    'email',
                    'status',
                    'userRoleName' => [
                        'asc' => ['item_name' => SORT_ASC],
                        'desc' => ['item_name' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Role Name',
                    ],
                    'profile.last_visit' => [
                        'asc' => ['item_name' => SORT_ASC],
                        'desc' => ['item_name' => SORT_DESC],
                        'default' => SORT_ASC,
                        'label' => 'Last Visit',
                    ]
                ]
            ],
        ]);
    }

    /**
     * @param array $params
     * @return mixed|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = $this->getQuery();
        $dataProvider = $this->getDataProvider($query);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        $this->processFilter($query);
        $dataProvider = $this->setTotalCount($query, $dataProvider);
        return $dataProvider;
    }

    /**
     * @param $query \yii\db\QueryInterface
     */
    protected function processFilter($query)
    {
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'item_name' => $this->userRoleName,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['>=', 'last_visit', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'last_visit', $this->date_from ? strtotime($this->date_from . ' 23:59:59') : null]);
    }

    /**
     * @param \yii\db\ActiveQuery $query
     * @param ActiveDataProvider $dataProvider
     * @return mixed
     */
    protected function setTotalCount($query, $dataProvider)
    {
        if (is_int($query->count())) {
            $dataProvider->pagination->totalCount = $query->count();
        }
        return $dataProvider;
    }
}
