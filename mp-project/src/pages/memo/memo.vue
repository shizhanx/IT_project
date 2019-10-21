<template>
  <div>
    <van-divider contentPosition="left">通告</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="announcment" placeholder="是什么通告呢？" />
    </form>
    <van-button plain icon="completed" type="primary" @click="onClickSubmit">提交</van-button>
  </div>
</template>

<script>
  import {setStorageSync} from '../../api/wechat'

  export default {
    data () {
      return {
        announcment: ''
      }
    },
    methods: {
      onClickSubmit() {
        setStorageSync('announcment', this.announcment)
        wx.switchTab({
          url: '/pages/index/main'
        })
        wx.showToast({title: '发布成功', icon: 'none'})
      }
    }
  }
</script>

<style scoped>
  .form-control {
    display: block;
    padding: 12px 12px;
    margin-bottom: 5px;
    height: 10px;
    border: 1px solid #ccc;
  }

</style>
