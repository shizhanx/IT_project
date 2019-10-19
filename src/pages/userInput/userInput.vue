<template>
  <div>
    <form class="form-container">
      <input type="text" class="form-control" v-model.lazy="name" placeholder="v-model.lazy" @change="onChange"/>
      <input type="text" class="form-control" v-model.lazy="description" placeholder="v-model.lazy" @change="onChange"/>
    </form>
    <p>标题: {{ name }}</p>
    <p>介绍: {{ description }}</p>
    <van-divider contentPosition="left">上传图片 最多三张喔~~</van-divider>
    <Upload ref="ch"/>
    <van-button plain icon="completed" type="primary" @click="getChild">提交</van-button>
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
    padding: 0 12px;
    margin-bottom: 5px;
    height: 10px;
    border: 1px solid #ccc;
  }
</style>
