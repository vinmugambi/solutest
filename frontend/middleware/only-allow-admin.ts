import { fetchUser } from "./user-already-authenticated";

export default defineNuxtRouteMiddleware(async () => {
  var destination = "";
  await fetchUser()
    .then((user) => {
      if (!user) {
        destination = "/auth?action=login";
      } else if (user?.role == "user") {
        destination = "app";
      }
    })
    .catch((e) => {
      console.log("admin", e);
      destination = "/";
    });
  if (destination.trim().length) return navigateTo(destination);
});
