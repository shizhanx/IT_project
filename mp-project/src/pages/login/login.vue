<template>
  <div>
    <div v-if="exist === '1'">
      <van-tag type="primary" size="large">欢迎回来, 亲爱的{{name}}~~</van-tag>
      <div class="description">
        <p>简介：</p>
        <van-tag mark type="warning" size="large">{{description}}</van-tag>
      </div>
      <div>
        <van-divider />
          <div class="newfamily">
            <van-button round icon="plus" type="primary" @click="onCreateFamilyClick">新建家族</van-button>
          </div>
        <van-divider contentPosition="left">点击进入家庭~</van-divider>
      </div>
      <div
        v-for="(family,i) in families"
        :key="i"
        @click='onClickFamily(family.family)'
        class="familyList"
      >
        <van-tag color="#99BBFF" type="primary" size="large">{{family.family}}</van-tag>
      </div>
      <div class="refresh">
        <van-button icon="replay" type="info" @click="refreshFamily">刷新</van-button>
      </div>
    </div>
    <div v-if="exist === '0'">
      <van-divider contentPosition="left">文字描述</van-divider>
      <form class="form-container">
        <input type="text" class="form-control" v-model.lazy="name" placeholder="请输入用户名"/>
      </form>
      <van-divider />
      <van-button round icon="success" type="primary" @click="onClickSubmit">提交</van-button>
      <div class="new">
        <van-button round icon="plus" type="info" @click="onCreateUserClick">新用户注册</van-button>
      </div>
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
  .new {
    position: absolute;
    left: 108px;
    top: 158px;
  }
  .description {
    position: relative;
    left:0;
    top: 5px;
  }
  .refresh {
    position: absolute;
    left: 160px;
    top: 120px;
  }
</style>
