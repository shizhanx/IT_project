<template>
  <div>
    <div v-if="exist === '1'">
      <p>欢迎回来, {{name}}</p>
      <p>{{description}}</p>
      <van-button plain icon="completed" type="primary" @click="onCreateFamilyClick">新建家族</van-button>
      <van-button plain icon="completed" type="primary" @click="refreshFamily">刷新家族</van-button>
      <div
        v-for="(family,i) in families"
        :key="i"
        @click='onClickFamily(family.family)'
      >{{family.family}}</div>
    </div>
    <div v-if="exist === '0'">
      <van-divider contentPosition="left">文字描述</van-divider>
      <form class="form-container">
        <input type="text" class="form-control" v-model.lazy="name" placeholder="请输入用户名"/>
      </form>
      <van-button plain icon="completed" type="primary" @click="onClickSubmit">提交</van-button>
      <van-button plain icon="completed" type="primary" @click="onCreateUserClick">新建用户</van-button>
    </div>
  </div>
</template>

<script>
  import Upload from '../../components/base/Upload'
  import {setStorageSync} from '../../api/wechat'

  export default {
    components: {
      Upload
    },
    data () {
      return {
        name: '',
        description: '',
        exist: '0',
        families: {}
      }
    },
    methods: {
      onClickSubmit() {
        this.$httpWX.post({
          url: 'objects/user/search/exact',
          data: {
            search: this.name
          }
        }).then(res => {
          if (res[0]) {
            this.description = res[0]['description']
            this.exist = '1'
            this.refreshFamily()
            setStorageSync('current_user', res[0])
          } else {
            wx.showToast({title: '找不到你', icon: 'none'})
          }
        })
      },
      refreshFamily() {
        this.$httpWX.post({
          url: 'relation/mysearch/userfamily',
          data: {
            search_by: 'user',
            value: this.name
          }
        }).then(res => {
          this.families = res
        })
      },
      onCreateUserClick() {
        this.$router.push({path: '/pages/createUser/main'})
      },
      onCreateFamilyClick() {
        this.$router.push({path: '/pages/createFamily/main'})
      },
      onClickFamily(family) {
        this.$httpWX.post({
          url: 'objects/family/search/exact',
          data: {
            search: family
          }
        }).then(res => {
          setStorageSync('current_family', res[0])
        })
        // this.$router.replace({path: '/pages/index/main'})
        wx.switchTab({
          url: '/pages/index/main'
        })
      }
    }
  }
</script>

<style>
  .form-control {
    display: block;
    padding: 12px 12px;
    margin-bottom: 5px;
    height: 10px;
    border: 1px solid #ccc;
  }
</style>
