<?php
/**
 * Created by PhpStorm.
 * User: aning
 * Date: 18-5-30
 * Time: 上午9:25
 */

namespace Admin\Controller;
use Think\Controller;

class ExampleController extends Controller
{
    public $m;
    public function _initialize()
    {
        $this->m=M('flows_main');
    }
    /*select列表*/
    public function select(){
        $this->m->select();
        //.flows_main.find({})

        $this->m->order('addtime')->select();
        //.flows_main.find({}).sort({"addtime":1})

        $this->m->order('addtime desc')->select();
        //.flows_main.find({}).sort({"addtime":-1})

        $this->m->limit('5')->select();
        //.flows_main.find({}).limit(5)

        $this->m->page('5,10')->select();
        //.flows_main.find({}).skip(40).limit(10)

        $this->m->field('addtime,title')->select();
        //.flows_main.find({},{"addtime":"","title":""})

        /**
         * 注意这里的条件查询要用数组
         * */
        $this->m->where('title=second')->select();
        //.flows_main.find({"_string":"title=second"})

        $this->m->where(array('title'=>'second'))->select();
        //..flows_main.find({"title":"second"})

        /**
         *模糊查询,正则匹配
         */
        $this->m->where(array('title'=>array('like','second')))->select();
        //.flows_main.find({"title":{"$regex":"second","$options":"i"}})


        echo $this->m->getLastSql();
    }
    /*find查找*/
    public function find(){

        $this->m->where(array('title'=>'second'))->find();
        //.flows_main.find({"title":"second"}).limit(1)

        /**
         * seqdb的主键就是这种形式,所以主键查询请使用数组
         * */
        $this->m->find(array('$oid' => '5add52204883966c4d000000' ));
        //.flows_main.find({"_id":{"$oid":"5add52204883966c4d000000"}}).limit(1)

        $this->m->where(array('_id'=>array('$oid' => '5add52204883966c4d000000' )))->getField('title');
        //.flows_main.find({"_id":{"$oid":"5add52204883966c4d000000"}},{"title":""}).limit(1)




        echo $this->m->getLastSql();
    }
    /*update更新*/
    public function update(){
        /**
         *主键更新
         */
        $this->m->save(array(
           '_id'=>array('$oid' => '5add52204883966c4d000000' ),
            'title'=>'first'
        ));
        //.flows_main.update({"_id":{"$oid":"5add52204883966c4d000000"}},{"$set":{"title":"first"}})

        /**
         *更新
         */
        $this->m->where(array('title'=>'first'))->save(array(
            'addtime'=>'2018-05-29'
        ));
        //.flows_main.update({"title":"first"},{"$set":{"addtime":"2018-05-29"}})


        echo $this->m->getLastSql();
    }
    /*insert 插入*/
    public function insert(){

        $this->m->add(array('title'=>'third'));
        //print_r($res);
        //.flows_main.insert({"title":"third"})
        //Array ( [errno] => 0 [_id] => 5b0e0acbf66556c8ac000000 )

        echo $this->m->getLastSql();
    }
    /*delete 删除*/
    public function del(){

        $this->m->delete(array('$oid'=>"5b0e0acbf66556c8ac000000"));
        //.flows_main.remove({"_id":{"$oid":"5b0e0acbf66556c8ac000000"}})

        echo $this->m->getLastSql();
    }
}