<style scoped>
</style>
<template>
    <div class="main" style="width: 500px;height: 500px">
        <div class="left" v-bind:style="{width:ths[0].width+'px'}">


            22222
        </div>
        <div class="right" @mousedown="drag" style="border: solid 1px red">

            333333
        </div>
    </div>
</template>

<script>
    import {smartpicAPI} from '../../api/index'

    export default {

        data() {
            return {
                ths:[
                    {width:'30'},
                    {width:''}
                ]
            }
        },
        mounted() {
        },
        methods:{
            drag:function(e,index){
                var Left=e.target.parentNode.children[0],
                    leftW=Left.offsetWidth,
                    startX=e.clientX;
                _this=this;
                console.log(_this);

                document.onmousemove=function(e){
                    e.preventDefault();
                    var distX=e.clientX-startX;
                    Left.style.width=leftW+distX+'px';
                    if(parseInt(Left.style.width)>=280){
                        Left.style.width=280+'px';
                    }
                }

                document.onmouseup=function(){
                    document.onmousemove=null;
                }
            }
        }
    }
</script>
