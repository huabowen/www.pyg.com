<?php

namespace app\common\model;

use think\Model;

class Goods extends Model
{
    //定义商品-商品分类关联 一个商品属于一个分类
    public function category()
    {
        return $this->belongsTo('Category', 'cate_id', 'id')->bind('cate_name');
    }
    public function categoryRow()
    {
        return $this->belongsTo('Category', 'cate_id', 'id');
    }
    //定义商品-商品品牌关联  一个商品属于一个品牌
    public function brand()
    {
        //将数据表中的name字段设置别名为brand_name
        return $this->belongsTo('Brand', 'brand_id', 'id')->bind(['brand_name'=>'name']);
    }
    public function brandRow()
    {
        //将数据表中的name字段设置别名为brand_name
        return $this->belongsTo('Brand', 'brand_id', 'id');
    }
    //定义商品-商品类型关联  一个商品属于一个类型
    public function type()
    {
        return $this->belongsTo('Type', 'type_id', 'id')->bind('type_name');
    }
    public function typeRow()
    {
        return $this->belongsTo('Type', 'type_id', 'id');
    }
    //定义商品-相册图片关联  一个商品有多个图片
    public function goodsImages()
    {
        return $this->hasMany('GoodsImages', 'goods_id', 'id');
    }
    //定义商品-规格商品SKU的关联  一个商品SPU 有多个 规格商品SKU
    public function specGoods()
    {
        return $this->hasMany('SpecGoods', 'goods_id', 'id');
    }
}
