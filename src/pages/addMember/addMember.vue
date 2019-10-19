<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="姓名"/>
      <input type="text" class="form-control" v-model.lazy="description" placeholder="简介"/>
      <input type="text" class="form-control" v-model.lazy="title" placeholder="称呼方式"/>
      <input type="text" class="form-control" v-model.lazy="generation" placeholder="辈分"/>
    </form>
    <van-divider contentPosition="left">上传族人照片图片 最多一张喔~~</van-divider>
    <Upload ref="ch"/>
    <van-button plain icon="completed" type="primary" @click="onClickSubmit">提交</van-button>
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
        title: '',
        generation: ''
      }
    },
    methods: {
      onClickSubmit() {
        let chil = this.$refs.ch
        this.$httpWX.post({
          url: 'objects/user/create',
          data: {
            current_user: getStorageSync('current_user'),
            current_family: getStorageSync('current_family'),
            name: this.name,
            description: this.description,
            title: this.title,
            generation: Number(this.generation),
            image: chil.urls
          }
        }).then(res => {
          if (res[0]) {
            wx.switchTab({
              url: '/pages/familyTree/main'
            })
            wx.showToast({title: '创建成功', icon: 'none'})
          }
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

