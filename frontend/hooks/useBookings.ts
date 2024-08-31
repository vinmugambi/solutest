export const useBookings = async () => {
  const { data, pending, error } = await useFetch(
    "http://localhost:8000/bookings",
    {
      query: {
        limit: 5,
      },
      credentials: "include",
    }
  );

  return { bookings: data, loading: pending, error };
};
