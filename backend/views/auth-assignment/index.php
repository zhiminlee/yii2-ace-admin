<?php

use \yii\helpers\Html;

// 定义标题和面包屑信息
$this->title = '角色分配';
$this->registerJsFile('@web/public/assets/js/chosen.jquery.min.js', ['depends' => 'backend\assets\AppAsset']);
$this->registerCssFile('@web/public/assets/css/chosen.css', ['depends' => 'backend\assets\AppAsset']);
?>
<!-- 表格按钮 -->
<!--<p id="me-table-buttons"></p>-->
<div class="well">
    <form id="search-form">
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">管理员</label>
                    <div class="col-sm-10">
                        <?=Html::dropDownList(
                            'user_id',
                            null,
                            $this->params['admins'],
                            [
                                'multiple' => 'multiple',
                                'class' => 'chosen-select tag-input-style',
                            ]
                        )?>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">分配角色</label>
                    <div class="col-sm-10">
                        <?=Html::dropDownList('item_name', null, $arrRoles, [
                            'multiple' => 'multiple',
                            'class' => 'chosen-select tag-input-style',
                        ])?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 pull-right" style="margin-top: 10px;">
                <div class="pull-right" id="me-table-buttons">
                    <button class="btn btn-info btn-sm">
                        <i class="ace-icon fa fa-search"></i> 搜索
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- 表格数据 -->
<table class="table table-striped table-bordered table-hover" id="show-table"></table>
<?php $this->beginBlock('javascript') ?>
<script type="text/javascript">
    var roles = <?=$roles?>,
        aAdmins = <?=\yii\helpers\Json::encode($this->params['admins'])?>;
    var m = meTables({
        searchType: "top",
        search: {
            render: false
        },
        title: "角色分配",
        buttons: {
            "updateAll": {bShow: false},
            "deleteAll": {bShow: false}
        },
        bCheckbox: false,
        operations: {
            "width": "auto",
            buttons: {
                "see": {"bShow": false},
                "update": {"bShow": false}
            }
        },
        table: {
            "order": [],
            "aoColumns": [
                {"title": "管理员", "data": "user_id", "sName": "user_id",
                    "value": aAdmins,
                    "edit": {"type": "select", "required": true},
                    "bSortable": false,
                    "createdCell": mt.adminString,
//                    "search": {
//                        "type": "select",
//                        "multiple": true,
//                        "id": "search-select",
//                        "class": "chosen-select"
//                    }
                },
                {"title": "对应角色", "data": "item_name", "sName": "item_name",
                    "value": roles,
                    "edit": {
                        "type": "select",
                        "multiple": true,
                        "id": "select-multiple",
                        "required": true,
                        "class": "tag-input-style width-100 chosen-select",
                        "data-placeholder": "请选择一个角色"
                    },
                    "bSortable": false,
                    "createdCell": function(td, data) {
                        $(td).html(roles[data] ? roles[data] : data);
                    },
//                    "search": {
//                        "type": "select",
//                        "multiple": true,
//                        "id": "search-select",
//                        "class": "chosen-select"
//                    }
                },
                {"title": "最初分配时间", "data": "created_at", "sName": "created_at",
                    "createdCell" : meTables.dateTimeString
                }
            ]       
        }
    });

    var $select = null;

    meTables.fn.extend({
        // 显示的前置和后置操作
        beforeShow: function(data, child) {
            $("#select-multiple").val([]).trigger("chosen:updated").next().css({'width': "100%"});
            return true;
        }
    });

     $(function(){
         m.init();

         // 选择表
         $select = $(".chosen-select").chosen({
             allow_single_deselect: false,
             width: "100%"
         });
     });
</script>
<?php $this->endBlock(); ?>