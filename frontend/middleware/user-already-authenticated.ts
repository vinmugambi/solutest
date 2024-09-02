import type { User } from "~/types";

export default defineNuxtRouteMiddleware(async (to, from) => {
  var destination = "";
  await fetchUser()
    .then((user) => {
      if (to.path) {
        destination = to.path;
      } else destination = "/dashboard";
    })
    .catch((e) => {
      console.log("auth", e);
    });

  if (destination) return navigateTo(destination);
});

export var fetchUser = async () => {
  var profileEndpoint = useRuntimeConfig().public.profileEndpoint;
  const headers = useRequestHeaders(["cookie"]);
  return await $fetch<User>(profileEndpoint, {
    headers,
  });
};
