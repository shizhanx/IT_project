<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="请输入用户名"/>
      <input type="text" class="form-control" v-model.lazy="description" placeholder="来！说上一句话！"/>
    </form>
    <van-divider contentPosition="left">上传图片 最多一张喔~~</van-divider>
    <Upload ref="ch"/>
    <van-button plain icon="completed" type="primary" @click="onClickSubmit">注册</van-button>
  </div>
</template>

<script>
  import Upload from '../../components/base/Upload'

  export default {
    components: {
      Upload
    },
    data () {
      return {
        name: '',
        description: ''
      }
    },
    methods: {
      onClickSubmit() {
        let chil = this.$refs.ch
        this.$httpWX.post({
          url: 'objects/user/create',
          data: {
            name: this.name,
            description: this.description,
            image: chil.urls
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
