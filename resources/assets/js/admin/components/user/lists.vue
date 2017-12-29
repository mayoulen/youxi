<template>
<section>   
    <el-container>
      <el-row style="width:100%">
        <el-col :span="8">
          <router-link to="/user-create">
            <el-button type="primary" icon="el-icon-plus" size="small">
              添加
            </el-button>
          </router-link>
        </el-col>
        <el-col :span="8">&nbsp;</el-col>
        <el-col :span="8">
          <el-input placeholder="可通过昵称，手机号搜索" size="small" 
            class="input-with-select" auto-complete="on" 
            v-model="filters.wd">
            <el-button slot="append" icon="el-icon-search"
            @click="getLists"></el-button>
          </el-input>
        </el-col>

        <el-col :span="24">
          <el-table :data="lists"
            :default-sort = "sort"
            @filter-change="filterChange"
            @sort-change="sortChange"
           style="width: 100%">
            <el-table-column 
              prop="name" label="昵称"> 
            </el-table-column>
            <el-table-column
              prop="mobile" label="手机号">
            </el-table-column>
            <el-table-column
              sortable='custom'
              prop="created_at" label="创建时间">
            </el-table-column>
            <el-table-column
              prop="is_admin"
              label="管理员"
              width="100"
              columnKey="is_admin"
              :filters="[{ text: '是', value: '1' }, { text: '否', value: '0' }]"
              :filter-multiple="false"
              filter-placement="bottom-end">
              <template slot-scope="scope">
                <el-tag
                  :type="scope.row.is_admin == '1' ? 'success' : 'danger'"
                  close-transition>{{scope.row.is_admin == '1' ? '是' : '否'}}</el-tag>
              </template>
            </el-table-column>
            <el-table-column
              prop="is_admin"
              label="代理商"
              width="100"
              columnKey="is_agent"
              :filters="[{ text: '是', value: '1' }, { text: '否', value: '0' }]"
              :filter-multiple="false"
              filter-placement="bottom-end">
              <template slot-scope="scope">
                <el-tag
                  :type="scope.row.is_agent == '1' ? 'success' : 'danger'"
                  close-transition>{{scope.row.is_agent == '1' ? '是' : '否'}}</el-tag>
              </template>
            </el-table-column>
            <el-table-column
              fixed="right" label="操作" width="120">
              <template slot-scope="scope">
                <el-button
                  @click.native.prevent="deleteRow(scope)"
                  type="text" size="small">
                  移除
                </el-button>
                <router-link :to="{name:'user-edit', params:{user_id:scope.row.id}}">
                  <el-button type="text" size="small">
                    编辑
                  </el-button>
                </router-link>
              </template>
            </el-table-column>
          </el-table>
        </el-col>
        <el-col  v-if="pagination.total/pagination.per_page > 1" :span="24" class="text-right" style="margin-top:15px">
          <el-pagination
            :current-page="pagination.page"
            :page-size="pagination.per_page"
            layout="total, prev, pager, next"
            @current-change="getLists"
            :total="pagination.total">
          </el-pagination>
        </el-col>
      </el-row>
    </el-container>

</section>



</template>

<script>
  export default {
    data() {
      return {
        lists: [],

        sort:{
          sort_prop: 'created_at', 
          sort_order: 'desc'
        },

        pagination:{
          page:1,
          per_page:15,
          total:0
        },

        filters:{
          is_admin : null,
          is_agent : null,
          wd       : null
        }
      };
    },
    mounted(){
      this.getLists();
    },
    methods: { 
        getLists:function(currentPage) {
            this.pagination.page = currentPage || 1;
            var params = Object.assign(
              {}, this.filters, this.pagination, this.sort
            );
            axios.get('/admin/user', { params:params }).then(response => {
                if(response.data.code == '200'){
                  var result = response.data.data;
                  this.lists = result.data;
                  this.pagination = {
                    page     : result.current_page,
                    per_page : result.per_page,
                    total    : result.total,
                  };
                }else{
                    this.$message.error(response.data.message);
                }
            })
            .catch(error => {
                this.$message.error('网络异常， 请稍后再试');
            });
        },

        filterChange:function(value){
          if( undefined != value.is_admin ){
            this.filters.is_admin = value.is_admin[0];
          }
          if( undefined != value.is_agent ){
            this.filters.is_agent = value.is_agent[0];
          }
          this.getLists();
        },

        sortChange:function(obj){
          this.sort.sort_prop = obj.prop;
          if(obj.order == 'descending'){
            this.sort.sort_order = 'desc';
          }else{
            this.sort.sort_order = 'asc';
          }
          this.getLists();
        },

        deleteRow:function(scope){
            axios.post('/admin/user/destory', {id:scope.row.id}).then(response => {
                if(response.data.code == '200'){
                  this.lists.splice(scope.$index, 1);
                }else{
                    this.$message.error(response.data.message);
                }
            })
            .catch(error => {
                this.$message.error('网络异常， 请稍后再试');
            });
          
        },

    }
  }
</script>
<style type="text/css">
  .el-table .caret-wrapper{
    margin-left: 1px !important;
  }
</style>
