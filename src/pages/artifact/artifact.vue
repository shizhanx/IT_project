<template>
  <div>
    <van-divider />
    <van-card
      desc="满满的垃圾 爽！"
      title="垃圾桶"
      thumb="/static/images/40.png"
    />
    <van-divider />
    <van-card
      desc="墨大Software Systems本科在读，正在毕业的边缘疯狂试探"
      title="客户之子"
      thumb="/static/images/42.jpg"
    />
    <van-divider />
    <van-card
      desc="儿子的偶像，具体信息请咨询客户之子"
      title="偶像"
      thumb="/static/images/43.jpg"
    />
    <van-divider />
    <van-card
      desc="没开的宝箱，开出啥都有可能"
      title="未开宝箱"
      thumb="/static/images/44.png"
    />
    <div class="add">
      <van-button icon="add-o" @click="toAddArtifactClick">添加传家宝</van-button>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
      toAddArtifactClick() {
        this.$router.push({path: '/pages/addArtifact/main'})
      }
    }
  }
</script>

<style lang="scss" scoped>
  .add {
    position: absolute;
    right: 20px;
    bottom: 20px;
  }
</style>
