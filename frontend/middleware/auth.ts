import type { User } from "~/types";

export default defineNuxtRouteMiddleware(async (to, from) => {
  if (to.params.id === "1" || from === to) {
    return abortNavigation();
  }
  var profileEndpoint = useRuntimeConfig().public.profileEndpoint;

  try {
    var res = await $fetch<User>(profileEndpoint, {
      credentials: "include",
    });
    if (res.role == "admin") {
      if (to.path) {
        return navigateTo(to);
      }
      return navigateTo("/app");
    } else {
      return navigateTo("/dashboard");
    }
  } catch (error) {
    // If there's an error, redirect to the login page
    // return navigateTo("/auth?action=login");
  }
});
