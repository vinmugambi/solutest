import { useState } from "#app";
import { type FetchStatus, type User } from "~/types";

export const useAuth = () => {
  var profileEndpoint = useRuntimeConfig().public.profileEndpoint;
  var logoutEndpoint = useRuntimeConfig().public.logoutEndpoint;

  var user = useState<User | null>("auth", () => null);
  var status = useState<FetchStatus>("idle");
  var router = useRouter();

  const checkAuthorization = () => {
    status.value = "pending";
    return $fetch<User>(profileEndpoint, {
      credentials: "include",
    })
      .then((res) => {
        user.value = res;
        status.value = "success";

        return res;
      })
      .catch(() => {
        user.value = null;
        status.value = "error";
        return null;
      });
  };

  function logout() {
    status.value = "pending";
    user.value = null;
    console.log("logging you out");
    $fetch(logoutEndpoint, {
      credentials: "include",
      method: "POST",
    })
      .then(() => {
        router.push("/auth?action=login");
        status.value = "success";
      })
      .catch((e) => {
        status.value = "error";
        console.error(e);
      });
  }

  return {
    user,
    checkAuthorization,
    logout,
    status,
  };
};
