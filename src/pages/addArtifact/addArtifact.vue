<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="取个名吧！" />
      <input type="text" class="form-control" v-model.lazy="description" placeholder="介绍一下" />
    </form>
    <p>名字: {{ name }}</p>
    <p>介绍: {{ description }}</p>
    <van-divider contentPosition="left">上传图片 最多一张喔~~</van-divider>
    <Upload ref="ch"/>
    <van-button plain icon="completed" type="primary" @click="onClickSubmit">提交</van-button>
  </div>
</template>

<script>
  import Upload from '../../components/base/Upload'
  // import {getStorageSync} from '../../api/wechat'

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
        // let chil = this.$refs.ch
        // this.$httpWX.post({
        //   url: 'objects/artifact/create',
        //   data: {
        //     name: this.name,
        //     description: this.description,
        //     image: chil.urls,
        //     current_user: getStorageSync('current_user')
        //   }
        // }).then(res => {
        //   if (res[0]) {
        //     wx.switchTab({
        //       url: '/pages/artifact/main'
        //     })
        //     wx.showToast({title: '创建成功', icon: 'none'})
        //   }
        // })
        wx.switchTab({
          url: '/pages/artifact/main'
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

