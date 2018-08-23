<style scoped>
    .el-header, .el-footer {
        background-color: #B3C0D1;
        color: #333;
        text-align: center;
        line-height: 60px;
    }

    .el-aside {
        background-color: #D3DCE6;
        color: #333;
        text-align: center;
        line-height: 200px;
        padding-top: 20px;
    }

    .el-main {
        background-color: #E9EEF3;
        color: #333;
        text-align: center;
        line-height: 160px;
        padding: 10px;
        overflow: hidden;
    }

    body > .el-container {
        margin-bottom: 40px;
    }

    .el-container:nth-child(5) .el-aside,
    .el-container:nth-child(6) .el-aside {
        line-height: 260px;
    }

    .el-container:nth-child(7) .el-aside {
        line-height: 320px;
    }
    .pic-background{
        width: 100%;
        height: 100%;
        border: 1px solid black;
        background-image: linear-gradient(45deg,rgba(0,0,0,.25) 25%,transparent 0,transparent 75%,rgba(0,0,0,.25) 0),
        linear-gradient(45deg,rgba(0,0,0,.25) 25%,transparent 0,transparent 75%,rgba(0,0,0,.25) 0);
        background-color: #eee;
        background-size: 30px 30px;
        background-position: 0 0,15px 15px;
    }

    #pic-box{
        position: relative;
        left: 50%;
        top: 50%;
    }
    .el-col-5{
        width: 20%;
    }
    .pic-element{
        position: absolute;
        word-break: keep-all;
    }
    .el-input-number{
        width: 100%;
    }
    #element-list{
        overflow-y: auto;
        max-height: 100%;
        top:0;
    }
    #smart-pic{
        line-height: 40px;
    }
</style>
<style>
    #smart-pic .el-input-number .el-input__inner ,#element-list .el-input-number .el-input__inner {
        padding: 0px;
    }
    #smart-pic .el-input-number__decrease,#smart-pic .el-input-number__increase,#element-list .el-input-number__decrease,#element-list .el-input-number__increase{
        width: 25px;
    }
</style>
<template>
    <el-container  style="height: 100%">
        <el-container>
            <el-main>
                <div class="pic-background">
                    <div id="pic-box"
                         :style="is_bold==1?('border: 5px solid black;'
                                +'width: '          + (info.width+4)*times      + 'px;'
                                +'height: '         + (info.height+4)*times     + 'px;'
                                +'margin-left: -'   + (info.width+4)*times/2    + 'px;'
                                +'margin-top: -'    + (info.height+4)*times/2   + 'px;'):
                                ('width: '          + info.width*times      + 'px;'
                                +'height: '         + info.height*times     + 'px;'
                                +'margin-left: -'   + info.width*times/2    + 'px;'
                                +'margin-top: -'    + info.height*times/2   + 'px;')">
                        <div class="pic-element" v-for="(item,key) in element" :key="key"
                             :style="(is_bold==1?'border: 2px dashed darkblue;':'')
                                    +'width:'       + item.width*times      + 'px;'
                                    +'height:'      + item.height*times     + 'px;'
                                    +'line-height:' + item.height*times     + 'px;'
                                    +'font-size:'   + item.size*times       + 'px;'
                                    +'z-index:'     + item.z+2000           + ';'
                                    +'text-align:'  + item.align            + ';'
                                    +'font-weight:' + (item.bold*100+100)   + ';'
                                    +'left:'        + item.x*times          + 'px;'
                                    +'top:'         + item.y*times          + 'px;'">
                            <span v-if="item.source_type==1&&item.source_id==0">{{item.source_local_value==""?item.placeholder:item.source_local_value}}</span>
                            <span v-if="item.source_type==1&&item.source_id!=0">动态文字</span>
                            <img v-if="item.source_type==2&&item.source_id==0&&item.source_local_value!=''" :src="item.source_local_value" :height="item.height*times" :width="item.width*times"/>
                            <img v-if="item.source_type==2&&item.source_id!=0" src="../../assets/timg.jpeg" :height="item.height*times" :width="item.width*times"/>
                        </div>

                    </div>
                </div>
            </el-main>
            <el-aside width="40%">
                <el-form :model="info" id="smart-pic" label-width="100px">
                    <el-row>
                        <el-col :span="22">
                            <el-form-item label="名称:">
                                <el-input v-model="info.name"></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="10">
                            <el-form-item label="宽度：">
                                <el-input-number v-model="info.width" :min="0" :max="2000"></el-input-number>
                            </el-form-item>
                        </el-col>
                        <el-col :span="1">px</el-col>
                        <el-col :span="10">
                            <el-form-item label="高度：">
                                <el-input-number v-model="info.height" :min="0" :max="2000"></el-input-number>
                            </el-form-item>
                        </el-col>
                        <el-col :span="1">px</el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="11">
                            <el-form-item label="预览倍数：">
                                <el-input-number v-model="times" :min="0" :max="5"></el-input-number>
                            </el-form-item>
                        </el-col>
                        <el-col :span="11">
                            <el-form-item label="挂件数:">
                                <el-input v-model="element.length" disabled=""></el-input>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-row>
                        <el-col :span="22">
                            <el-form-item label="预览图:">
                                <div id="myCanvas_box" style="min-height: 200px;min-width: 300px;border:1px solid slategray;margin-top: 10px;padding: 10px">
                                    <img :src="info.img_url"/>
                                </div>
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
            </el-aside>
        </el-container>
        <el-footer style="height: 40%;padding-top: 60px">
            <el-row style="margin-top: -60px">
                <el-col :span="12" align="left">
                    <span>套用模板:</span>
                    <el-select v-model="tem_val" placeholder="请选择" @change="changeTem">
                        <el-option
                                v-for="(item,key) in tem"
                                :key="key"
                                :label="item.name"
                                :value="key">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :span="12" align="right">
                    <el-button type="success" round @click="addElement">新增</el-button>
                    <el-button type="warning" round @click="pic">生成预览图</el-button>
                    <el-button type="primary" round @click="save">保存</el-button>
                </el-col>
            </el-row>
            <el-row id="element-list">
                <el-form label-width="80px">
                    <el-row v-for="(item,key) in element" :key="key" style="border: solid 1px beige;padding: 5px">
                        <el-col :span="20" style="padding: 10px">
                            <el-col :span="5">
                                <el-form-item label="宽度：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.width" :min="0" :max="2000"></el-input-number>
                                    </el-col>
                                    <el-col class="line" :span="4">px</el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="高度：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.height" :min="0" :max="2000"></el-input-number>
                                    </el-col>
                                    <el-col class="line" :span="4">px</el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="x坐标：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.x" :min="0" :max="2000"></el-input-number>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="y坐标：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.y" :min="0" :max="2000"></el-input-number>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="图层：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.z" :min="0" :max="2000"></el-input-number>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="限制：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.limit" :min="0" :max="50"></el-input-number>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="占位符：">
                                    <el-col :span="20">
                                        <el-input v-model="item.placeholder"></el-input>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="类型：">
                                    <el-col :span="20">
                                        <el-select v-model="item.source_type" placeholder="请选择" @change="clearLocalValue(item)">
                                            <el-option label="文字" value="1"></el-option>
                                            <el-option label="图片" value="2"></el-option>
                                        </el-select>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5">
                                <el-form-item label="数据源：">
                                    <el-col :span="20">
                                        <el-select v-model="item.source_id" placeholder="请选择" @change="clearLocalValue(item)">
                                            <el-option label="默认"         value="0"></el-option>
                                            <el-option label="智能数据源"    value="2"></el-option>
                                        </el-select>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_id!=0">
                                <el-form-item label="参数：">
                                    <el-col :span="20">
                                        <el-input v-model="item.source_local_value" :placeholder="item.placeholder"></el-input>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_id==0&&item.source_type==1">
                                <el-form-item label="文字：">
                                    <el-col :span="20">
                                        <el-input v-model="item.source_local_value" :placeholder="item.placeholder"></el-input>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_type==1">
                                <el-form-item label="字号：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.size" :min="0" :max="100"></el-input-number>
                                    </el-col>
                                    <el-col class="line" :span="4">px</el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_type==1">
                                <el-form-item label="颜色：">
                                    <el-col :span="20">
                                        <el-color-picker v-model="item.color"></el-color-picker>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_type==1">
                                <el-form-item label="加粗：">
                                    <el-col :span="20">
                                        <el-input-number v-model="item.bold" :min="0" :max="8"></el-input-number>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_type==1">
                                <el-form-item label="对齐：">
                                    <el-col :span="20">
                                        <el-select v-model="item.align" placeholder="请选择">
                                            <el-option label="居左" value="left"></el-option>
                                            <el-option label="居右" value="right"></el-option>
                                            <el-option label="居中" value="center"></el-option>
                                        </el-select>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                            <el-col :span="5" v-if="item.source_id==0&&item.source_type==2">
                                <el-form-item label="图片：">
                                    <el-col :span="20">
                                        <el-input v-model="item.source_local_value" :placeholder="item.placeholder"></el-input>
                                    </el-col>
                                </el-form-item>
                            </el-col>
                        </el-col>
                        <el-col :span="4" style="border: dashed 1px whitesmoke;padding: 10px">
                            <el-form-item label="名称：">
                                <el-input v-model="item.name"></el-input>
                            </el-form-item>
                            <el-button type="danger" plain style="width: 100%" @click="removeElement(key)">删除</el-button>
                        </el-col>
                    </el-row>
                </el-form>
            </el-row>
        </el-footer>
    </el-container>
</template>

<script>
    import {smartpicAPI} from '../../api/index'
    import ElRow from "element-ui/packages/row/src/row";
    import html2canvas from 'html2canvas'

    export default {
        components: {ElRow},
        data() {
            return {
                defaultImg : "../../assets/timg.jpeg",
                info    : {
                    "img_url"   : "2",
                    "name"      : "3",
                    "width"     : "200",
                    "height"    : "100",
                },
                is_bold:1,
                times : 1,
                tem : [],
                tem_val : [],
                element : [],
                elementModel : {
                    name: "",
                    x: "",
                    y: "",
                    z: "",
                    source_type: "",
                    source_id: "",
                    source_local_value: "",
                    height: "",
                    width: "",
                    size: "",
                    color: "",
                    bold: "",
                    align: "",
                    limit: "",
                    placeholder: "",
                }
            }
        },
        mounted() {
            this.init()
        },
        methods: {
            init() {
                smartpicAPI.getFrame({} , (data) => {
                    this.tem = data
                })
                if(this.$route.query.id!=null){
                    let param = {
                        id:this.$route.query.id
                    }
                    smartpicAPI.getById(param , (data) => {
                        this.setData(data)
                    })
                }
            },
            setData(data){
                if(this.$route.query.id!=null)  this.info.id = this.$route.query.id
                this.element 		= data.element
                this.info.img_url	= data.img_url
                this.info.name		= data.name
                this.info.width		= data.width
                this.info.height	= data.height
            },
            changeTem(key){
                let tem = JSON.parse(JSON.stringify(this.tem[key]))
                this.setData(tem)
            },
            addElement(){
                this.element.unshift(JSON.parse(JSON.stringify(this.elementModel)))
            },
            removeElement(key){
                this.element.splice(key,1)
            },
            clearLocalValue(item){
                item.source_local_value = ""
            },
            save(){
                let param = this.info
                param.element = this.element
                smartpicAPI.save(param , (data) => {
                    this.$message('成功，id：'+data.id);
                })
            },
            pic(){
                let _this = this;
                _this.is_bold = 0;
                setTimeout(function () {
                    html2canvas(document.getElementById('pic-box'),{
                        allowTaint:true,
//                        width:_this.info.width+10,
                    }).then(function(canvas) {
                        let box = document.getElementById('myCanvas_box')
                        box.replaceChild(canvas,box.childNodes[0])
                        _this.is_bold = 1;
//                    console.log(canvas.toDataURL("image/png"))
                    })
                }, 100);


            }
        }
    }
</script>
