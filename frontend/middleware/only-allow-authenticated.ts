import { fetchUser } from "./user-already-authenticated";

export default defineNuxtRouteMiddleware(() => {
  var destination = "";
  fetchUser().catch((e) => {
    destination = "/";
  });
  if (destination) return navigateTo(destination);
});
