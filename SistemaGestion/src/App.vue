<template>
  <router-view />
</template>

<script>
export default {
  name: 'App',
  created() {
      const currentPath = this.$router.history.current.path;
    if (!this.$session.exists()) {
      this.$router.push('/login').catch(err => {
       // Ignore the vuex err regarding  navigating to the page they are already on.
            if (
              err.name !== 'NavigationDuplicated' &&
              !err.message.includes('Evitó la navegación redundante a la ubicación actual')
            ) {
              // But print any other errors to the console
              console(err);
            }
          });
    }
  },

  methods:{  
    }
};
</script>

<style src="./styles/theme.scss" lang="scss" />
