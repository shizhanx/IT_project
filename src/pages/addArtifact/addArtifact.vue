<template>
  <div>
    <van-divider contentPosition="left">文字描述</van-divider>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="v-model.lazy" @change="onChange"/>
      <input type="text" class="form-control" v-model.lazy="description" placeholder="v-model.lazy" @change="onChange"/>
    </form>
    <p>名字: {{ name }}</p>
    <p>介绍: {{ description }}</p>
    <van-divider contentPosition="left">上传图片 最多一张喔~~</van-divider>
    <Upload ref="ch"/>
    <van-button plain icon="completed" type="primary" @click="getChild">提交</van-button>
  </div>
</template>

<script>
  import Upload from '../../components/base/Upload'
  import Toast from 'vant-weapp/dist/toast/toast'

  export default {
    components: {
      Upload
    },
    data () {
      return {
        name: '取个名吧！',
        description: '说明一下！'
      }
    },
    methods: {
      onChange(event) {
        // event.detail 为当前输入的值
        console.log(event.detail)
      },
      getChild() {
        wx.request({
          url: 'http://localhost/ci/index.php/objects/artifact/create',
          data: {
            'name': this.name,
            'description': this.description,
            'current_user': '???'
          },
          method: 'POST',
          header: {
            'content-type': 'application/x-www-form-urlencoded'
          },
          success: function (res) {
            if (res.data[0]['error']) {
              Toast.fail(res.data[0]['error'])
            }
          }
        })
        let chil = this.$refs.ch
        console.log(chil.urls)
        console.log(this.name)
        console.log(this.description)
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

