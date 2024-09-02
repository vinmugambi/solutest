import { fetchUser } from "./user-already-authenticated";

export default defineNuxtRouteMiddleware(async () => {
  try {
    const user = await fetchUser().catch();
    if (user?.role != "admin") {
      return navigateTo("/dashboard");
    }
    return;
  } catch (e) {
    console.log("admin", e);
  }
});
