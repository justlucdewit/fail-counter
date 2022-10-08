<template>
  <div id="app">
    <div id="top">
      <img src="@/assets/derpluke.png"></img>
    </div>

    <div id="bottom">
      {{ failCount }} Fails in total!

      <br /><br />

      <input type="password" v-model="password" /> <br />

      <button @click="addFail()">Add fail</button>
    </div>
  </div>
</template>

<script>

export default {
  data: () => ({
    failCount: 0,
    api: "http://localhost:80/api",
    password: ""
  }),

  mounted() {
    this.getFailCount();
  },

  methods: {
    getFailCount() {
      const that = this;
      fetch(this.api)
        .then(response => response.text())
        .then(data => {
          that.failCount = data;
        });
    },

    addFail() {
      const that = this;
      fetch(this.api + `?pass=${that.password}`, {
        method: "POST"
      })
        .then(response => response.text())
        .then(data => {
          that.getFailCount();
        });
    }
  }
}
</script>

<style lang="scss">
body {
  padding: 0;
  margin: 0;
}

#top {
  height: 50vh;

  img {
    width: 100%;
    height: 80%;
    margin-top: 5%;
    object-fit: contain;

    // make pixelart crisp
    image-rendering: pixelated;
  }
}

#bottom {
  text-align: center;
  height: 50vh;
  font-size: 50px;
}

button {
  font-size: 30px;
  padding: 10px;
  border-radius: 10px;
  border: 1px solid black;
  background-color: #f0f0f0;
  cursor: pointer;
}

input {
  font-size: 30px;
  padding: 10px;
  border-radius: 10px;
  border: 1px solid black;
  background-color: #f0f0f0;
  width: calc(100% - 40px);
  max-width: 200px;
}
</style>
