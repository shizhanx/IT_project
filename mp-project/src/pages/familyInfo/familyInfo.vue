<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model="name" placeholder="请输入新家族名" />
      <input type="text" class="form-control" v-model="description" placeholder="请输入新家族介绍" />
    </form>
    <van-button plain icon="completed" type="primary" @click="onClickSubmit">提交</van-button>
  </div>
</template>

<script>
  import Upload from '../../components/base/Upload'
  import {getStorageSync, setStorageSync} from '../../api/wechat'

  export default {
    components: {
      Upload
    },
    data () {
      return {
        old_name: getStorageSync('current_family')['name'],
        name: getStorageSync('current_family')['name'],
        description: getStorageSync('current_family')['description']
      }
    },
    methods: {
      onClickSubmit() {
        this.$httpWX.post({
          url: 'objects/family/edit',
          data: {
            old_name: this.old_name,
            name: this.name,
            description: this.description
          }
        }).then(res => {
          if (res[0]) {
            console.log(res)
            setStorageSync('current_family', res[0])
            wx.switchTab({
              url: '/pages/index/main'
            })
            wx.showToast({title: '修改成功', icon: 'none'})
          }
        })
        console.log()
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
