<template>
<section>   
    <el-container>
        <el-header>后台登入</el-header>
        <el-main>
            <el-form label-position="left" label-width="80px" :model="loginForm">
              <el-form-item label="手机号:">
                <el-input v-model="loginForm.mobile"></el-input>
              </el-form-item>
              <el-form-item label="密    码:">
                <el-input type="password" v-model="loginForm.password"></el-input>
              </el-form-item>

              <el-button type="primary" @click="submitForm()">登 录</el-button>
            </el-form>
        </el-main>
    </el-container>

</section>



</template>

<script>
  export default {
    data() {
      return {
        loginForm: {
          mobile: '',
          password: '',
        },
      };
    },
    methods: {
        submitForm() {
            axios.post('/admin/login', this.loginForm).then(response => {
              console.log(response);
                if(response.data.code == '200'){
                    this.$message({
                      message: '登入成功， 正在为您跳转',
                      type: 'success'
                    });
                    window.location.href = '/admin/dashboard';
                }else{
                    this.$message.error(response.data.message);
                }

            })
            .catch(error => {
                this.$message.error('网络异常， 请稍后再试');
            });
        }
    }
  }
</script>

<style type="text/css">
    .el-container{
        width: 600px;
        margin: 100px auto auto auto;
    }
    .el-button{
        width: 100%
    }
    .el-header{
        height: 60px;
        text-align: center;
        font-size: 36px;
    }
</style>
