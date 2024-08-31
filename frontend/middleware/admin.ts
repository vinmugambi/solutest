import { useAuth } from "~/hooks/useAuth";

export default defineNuxtRouteMiddleware((to, from) => {
  const { checkAuthorization } = useAuth();
  checkAuthorization();
});
