export const useTours = async (query: {
  limit: number;
  destination_id: string;
  min_price: number;
  max_price: number;
  min_start_time: string;
  min_end_time: string;
  order_by: string;
}) => {
  const { data, pending, error } = await useFetch(
    "http://localhost:8000/api/tours",
    {
      query,
      // credentials: "include",
    }
  );

  return { tours: data, loading: pending, error };
};
