<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="家族名称"/>
      <input type="text" class="form-control" v-model.lazy="description" placeholder="描述"/>
    </form>
    <van-divider contentPosition="left">上传图片 最多一张喔~~</van-divider>
    <div>{{current_user}}</div>
    <van-button plain icon="completed" type="primary" @click="onClickSubmit">新建</van-button>
  </div>
</template>

<script>
  import Upload from '../../components/base/Upload'
  import {getStorageSync} from '../../api/wechat'

  export default {
    components: {
      Upload
    },
    data () {
      return {
        name: '',
        description: '',
        current_user: ''
      }
    },
    methods: {
      onClickSubmit() {
        this.current_user = getStorageSync('current_user')
        this.$httpWX.post({
          url: 'objects/family/create',
          data: {
            name: this.name,
            description: this.description,
            current_user: this.current_user
          }
        }).then(res => {
          this.$router.push({path: '/pages/login/main'})
          wx.showToast({title: '注册成功', icon: 'none'})
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
