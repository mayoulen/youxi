<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

  </head>
  
  <body>
    <div id="moniAdmin">
      <el-container>
        <el-header>
          <el-row>
            <el-col :span="6">
              <img src="/common/logo.svg" class="nav-logo">
            </el-col>
            <el-col :span="6">&nbsp;</el-col>
            <el-col :span="6">&nbsp;</el-col>
            <el-col :span="6" class="text-right">
              <el-button type="text">退出</el-button>
            </el-col>
          </el-row>

        </el-header>
        <el-container class="layout-content">
          <vue-scrolly class="foo" :style="{ width: '240px', height: '500px' }">
            <vue-scrolly-viewport>
              <el-aside class="layout-aside">
                <el-menu default-active="1-4-1" :router="true">
                  <el-submenu index="1">
                    <template slot="title">
                      <i class="el-icon-location"></i>
                      <span slot="title">用户管理</span>
                    </template>
                    <el-menu-item-group>
                      <el-menu-item index="/user-lists">管理员</el-menu-item>
                      <el-menu-item index="1-2">代理商</el-menu-item>
                      <el-menu-item index="1-2">会员</el-menu-item>
                    </el-menu-item-group>
                  </el-submenu>
                  <el-menu-item index="2">
                    <i class="el-icon-menu"></i>
                    <span slot="title">导航二</span></el-menu-item>
                  <el-menu-item index="3">
                    <i class="el-icon-setting"></i>
                    <span slot="title">导航三</span></el-menu-item>
                </el-menu>
              </el-aside>
            </vue-scrolly-viewport>
            <vue-scrolly-bar axis="y" style="width:4px"></vue-scrolly-bar>
          </vue-scrolly>
          <vue-scrolly class="foo" :style="{ width: '100%', height: '500px' }">
            <vue-scrolly-viewport>
              <el-main class="layout-main">
                <transition name="el-zoom-in-center">
                  <router-view></router-view>
                </transition>
              </el-main>
            </vue-scrolly-viewport>
            <vue-scrolly-bar axis="y" style="width:4px"></vue-scrolly-bar>
          </vue-scrolly>
        </el-container>
      </el-container>
    </div>
    <style type="text/css">
      .layout-main{ 
        min-height: 420px; 
      } 
      .el-header{ 
        width: 100%;
        line-height: 60px;
      } 
      .layout-content{ 

      } 
      .layout-aside{ 
        width: 240px; 
      }
    </style>
    <script src="{{ asset('admin/js/main.js') }}"></script>

  </body>

</html>