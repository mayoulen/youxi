<template>
  <section>
    <el-form ref="form" label-width="80px">
      <el-tabs v-model="activeName">
        <el-tab-pane label="账号信息" name="first">
          <el-row>
            <el-col :span="10">
              <el-form-item label="手机号">
                <el-input v-model="form.mobile"></el-input>
              </el-form-item>
              <el-form-item label="昵称">
                <el-input v-model="form.name"></el-input>
              </el-form-item>
              <el-form-item label="密码">
                <el-input type="password" placeholder="不修改则留空" v-model="form.password"></el-input>
              </el-form-item>
            </el-col>
          </el-row>
        </el-tab-pane>
        <el-tab-pane label="基本信息" name="second">
          <el-row>
            <el-col :span="10">
              <el-form-item label="头像">
                <el-upload class="avatar-uploader" action="/api/file/upload" :data="{classify:'headimgurl'}" :show-file-list="false" :with-credentials="true" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload">
                  <img v-if="form.headimgurl" :src="'/storage/'+form.headimgurl" class="avatar">
                  <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
              </el-form-item>
              <el-form-item label="地区">
                <vue-region :value="region" @update="updateRegion"></vue-region>
              </el-form-item>
              <el-form-item label="性别">
                <el-radio-group v-model="form.sex">
                  <el-radio label="0">未知</el-radio>
                  <el-radio label="2">男</el-radio>
                  <el-radio label="3">女</el-radio></el-radio-group>
              </el-form-item>
            </el-col>
          </el-row>
        </el-tab-pane>
        <el-tab-pane label="角色信息" name="third">
          <el-row style="margin:15px 0">
            <el-col :span="10">
              <el-switch v-model="form.is_admin" :active-value="1" :inactive-value="0" active-text="允许登入后台" inactive-text="不允许登入后台"></el-switch>
            </el-col>
          </el-row>
          <el-row style="margin:15px 0">
            <el-col :span="10">
              <el-switch v-model="form.is_agent" :active-value="1" :inactive-value="0" active-text="代理商" inactive-text="普通会员"></el-switch>
            </el-col>
          </el-row>
        </el-tab-pane>
      </el-tabs>
      <el-form-item>
        <el-button type="primary" @click="submitForm">修改</el-button></el-form-item>
    </el-form>
  </section>
</template>

<script>
  export default {
    props:['user_id'],
    data:function() {
      return {
        activeName:"first",
        form: {
          id:this.user_id,
          mobile: '',
          name: '',
          sex: '0',
          is_admin: 0,
          is_agent: 0,
          headimgurl: '',
          province:'',
          city:'',
          country:''
        }
      }
    },
    watch:{
      user_id:function(val){
        this.form.id = val;
      }
    },

    computed:{
      region:function(){
        return [this.form.province, this.form.city, this.form.country];
      }
    },

    mounted(){
      this.getInfo();
    },

    methods: {
      updateRegion:function(val){
        this.form.province = val[0];
        this.form.city     = val[1];
        this.form.country  = val[2];
      },

      getInfo:function(){
        axios.get('/admin/user/info?id='+this.form.id).then(response => {
            if(response.data.code == '200'){
             this.form = response.data.data;
            }else{
                this.$message.error(response.data.message);
                this.$router.push({name:'user-lists'});
            }

        })
        .catch(error => {
            this.$message.error('网络异常， 请稍后再试');
            this.$router.push({name:'user-lists'});
        });
      },

      submitForm:function() {
        axios.post('/admin/user/edit', this.form).then(response => {
            if(response.data.code == '200'){
                this.$message({
                  message: '创建成功',
                  type: 'success'
                });
                this.$router.push({name:'user-lists'});
            }else{
                this.$message.error(response.data.message);
            }

        })
        .catch(error => {
            this.$message.error('网络异常， 请稍后再试');
        });
      },
      handleAvatarSuccess:function(res, file) {
        if(res.code == '200'){
          this.form.headimgurl = res.data.path;
        }else{
          this.$message.error('头像上传失败');
        }
      },
      beforeAvatarUpload:function(file) {
        const isJPG = file.type.substr(0, 6) === 'image/';
        const isLt1M = file.size / 1024 / 1024 < 1;

        if (!isJPG) {
          this.$message.error('上传头像只能是图片格式');
        }
        if (!isLt1M) {
          this.$message.error('上传头像图片大小不能超过 1MB!');
        }
        return isJPG && isLt1M;
      }

    }
  }
</script>

<style>
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 120px;
    height: 120px;
    line-height: 120px;
    text-align: center;
  }
  .avatar {
    width: 120px;
    height: 120px;
    display: block;
  }
  input[type="file"]{
    display: none !important;
  }
</style>

