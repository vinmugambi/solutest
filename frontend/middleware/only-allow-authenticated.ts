import { fetchUser } from "./user-already-authenticated";

export default defineNuxtRouteMiddleware((to, from) => {
  var user = fetchUser().catch((e) => {});
  if (!user) {
    return navigateTo(`/auth?action=login&redirect=${to.fullPath}`);
  }
});
