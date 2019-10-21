<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="标题" />
      <input type="text" class="form-control" v-model.lazy="description" placeholder="详情" />
    </form>
    <van-divider contentPosition="left">上传图片 最多一张喔~~</van-divider>
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
        description: ''
      }
    },
    methods: {
      onClickSubmit() {
        let chil = this.$refs.ch
        this.$httpWX.post({
          url: 'objects/event/create',
          data: {
            current_user: getStorageSync('current_user')['name'],
            current_family: getStorageSync('current_family')['name'],
            name: this.name,
            description: this.description,
            date: getStorageSync('date_selected'),
            image: chil.urls
          }
        }).then(res => {
          if (res[0]) {
            wx.switchTab({
              url: '/pages/calendar/main'
            })
            wx.showToast({title: '创建成功', icon: 'none'})
          }
        })
      }
    },
    onUnload() {
      this.name = ''
      this.description = ''
      this.$refs.ch.urls = []
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
