import { watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useApiRoutes } from "~/composables/useApiRoutes";
import type { User } from "~/types";

export async function useAuth() {
  const { profileEndpoint, logoutEndpoint } = useApiRoutes();
  const headers = useRequestHeaders(["cookie"]);
  const router = useRouter();
  const route = useRoute();
  const currentPath = route.fullPath;

  const { data, status, error } = await useFetch<User>(profileEndpoint, {
    headers,
    credentials: "include",
  }).catch();

  // Watch the status and redirect to login if there's an error
  watch(status, (val) => {
    console.log("authStatus", status, error);
    if (val == "error") {
      router.push("/auth?action=login");
    }
  });

  // Function to handle logout
  function logout() {
    $fetch(logoutEndpoint, {
      method: "POST",
      credentials: "include",
    })
      .then(() => {
        router.push("/auth?action=login");
      })
      .catch((e) => {
        console.error(e);
      });
  }

  return {
    data,
    status,
    error,
    logout,
    currentPath,
  };
}
