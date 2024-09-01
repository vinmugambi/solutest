import { fetchUser } from "./user-already-authenticated";

export default defineNuxtRouteMiddleware(async () => {
  try {
    const user = await fetchUser().catch();
    if (!user) {
      return navigateTo("/auth?action=login");
    }
    return;
  } catch (e) {
    console.log("admin", e);
  }
});
