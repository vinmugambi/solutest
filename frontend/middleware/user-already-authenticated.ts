import type { User } from "~/types";

export default defineNuxtRouteMiddleware(async (to, from) => {
  var destination = "";
  await fetchUser()
    .then((user) => {
      if (user?.role == "admin") {
        destination = "/dashboard";
      } else if (user.role == "user") {
        destination = "/app";
      }
    })
    .catch((e) => {
      console.log("auth", e);
    });

  if (destination) return navigateTo(destination);
});

export var fetchUser = () => {
  var profileEndpoint = useRuntimeConfig().public.profileEndpoint;
  return $fetch<User>(profileEndpoint, {
    credentials: "include",
  });
};

export var logout = () => {
  var endpoint = useRuntimeConfig().public.logoutEndpoint;
  return $fetch<User>(endpoint, {
    credentials: "include",
  });
};
