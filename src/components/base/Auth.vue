<template>
  <div class="authorized">
    <div class="auth-wrapper">
      <div class="auth-info-wrapper">
        <div class="auth-img">
          <ImageView
            src="data:image/jpeg;base64,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"
            height="100%"
            mode="scaleToFill"
            round
          ></ImageView>
        </div>
        <div class="auth-text">登录Aqour家族</div>
        <div class="auth-strong-text">家人关系近近近</div>
      </div>
      <button
        class="auth-btn"
        @getuserinfo="getUserInfo"
        open-type="getUserInfo"
        plain="true"
        v-if="platform === 'wx'"
      >
        授权登录
      </button>
      <button
        class="auth-btn"
        plain="true"
        open-type="getAuthorize"
        scope='userInfo'
        v-else
      >
        授权登录
      </button>
    </div>
  </div>
</template>

<script>
  import ImageView from '../base/ImageView'

  export default {
    components: {
      ImageView
    },
    data() {
      return {
        platform: mpvuePlatform
      }
    },
    methods: {
      getUserInfo(res) {
        this.$emit('getUserInfo', res)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .authorized {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background: #999999;

    .auth-wrapper {
      position: relative;
      width: 270px;
      height: 248px;
      background: #f5f5f5;
      border-radius: 18px;

      .auth-info-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 22.5px;

        .auth-img {
          width: 74px;
          height: 74px;
        }

        .auth-text {
          font-size: 13px;
          color: #999;
          margin-top: 18px;
        }

        .auth-strong-text {
          font-size: 16px;
          color: #333;
          margin-top: 3.5px;
          font-weight: 500;
        }
      }

      .auth-btn {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 49px;
        line-height: 49px;
        font-size: 15px;
        font-weight: 500;
        background-image: linear-gradient(270deg, #1EA3F5 0%, #0F87FC 100%);
        color: #fff;
        border: none;
        border-radius: 0 0 18px 18px;
      }
    }
  }
</style>

