<template>

  <el-cascader
    placeholder="试试搜索：指南"
    :options="options"
    v-model="defaultValue"
    filterable
    change-on-select
  ></el-cascader>

</template>

<script>
  export default {
    props:{
      value:Array,
      default:function(){
        return [];
      }
    },
    data() {
      return {
        options: [],
        defaultValue:this.value
      }
    },
    watch:{
      value(val){
        this.defaultValue = val;
      },
      defaultValue(val){
        this.$emit('update', val);
      }
    },
    mounted(){
      this.getOptions();
    },
    methods: {
      getOptions(){
        axios.post('/admin/region').then(response => {
            if(response.data.code == '200'){
                this.options = response.data.data;
            }else{
                this.options = [];
            }

        })
        .catch(error => {
            this.$message.error('城市列表加载失败');
        });
      }
    }
  }
</script>
