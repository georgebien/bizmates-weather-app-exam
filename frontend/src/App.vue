<template>
  <div id="app">
    <weather-app></weather-app>
  </div>
</template>

<script>
import weatherApp from './views/weatherApp.vue'

export default {
  name: 'App',
  components: {
    weatherApp
  }
}
</script>

<style>
@import "./assets/css/main.css";
#app {
  min-height: 100vh;
  height: 100%;
  background-image: url('./assets/bg1.jpg');
  background-size: cover;
  color: rgb(36, 36, 36) !important;
}
</style>
