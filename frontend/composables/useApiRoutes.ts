export function useApiRoutes() {
  var apiBase = useRuntimeConfig().public.apiBase;

  return {
    toursEndpoint: apiBase + "/api/tours",
    destinationsEndpoint: apiBase + "/api/destinations",
    bookingsEndpoint: apiBase + "/bookings",
    ticketsEndpoint: apiBase + "/tickets",
    loginEndpoint: apiBase + "/login",
    logoutEndpoint: apiBase + "/logout",
    registerEndpoint: apiBase + "/register",
    profileEndpoint: apiBase + "/user",
  };
}
