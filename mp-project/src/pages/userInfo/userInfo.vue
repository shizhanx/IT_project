<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model="name" placeholder="请输入新用户名" />
      <input type="text" class="form-control" v-model="description" placeholder="请输入新自我介绍" />
    </form>
    <van-divider contentPosition="left">上传图片 最多一张喔~~</van-divider>
    <Upload ref="ch"/>
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
        old_name: getStorageSync('current_user')['name'],
        name: getStorageSync('current_user')['name'],
        description: getStorageSync('current_user')['description']
      }
    },
    methods: {
      onClickSubmit() {
        let chil = this.$refs.ch
        var image = chil.urls
        if (chil.urls.toString().length === 0) {
          image = getStorageSync('current_user')['image']
        }
        this.$httpWX.post({
          url: 'objects/user/edit',
          data: {
            old_name: this.old_name,
            name: this.name,
            description: this.description,
            image: image
          }
        }).then(res => {
          if (res[0]) {
            console.log(res)
            setStorageSync('current_user', res[0])
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
