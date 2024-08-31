// https://nuxt.com/docs/api/configuration/nuxt-config

var apiBase = "http://localhost:8000";

export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: true },
  modules: ["@nuxt/ui", "@nuxt/image"],
  runtimeConfig: {
    public: {
      toursEndpoint: apiBase + "/tours",
      loginEndpoint: apiBase + "/login",
      logoutEndpoint: apiBase + "/logout",
      registerEndpoint: apiBase + "/register",
      profileEndpoint: apiBase + "/user",
    },
  },
});
