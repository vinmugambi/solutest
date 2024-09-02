export interface Tour {
  id: number;
  destination_id: number;
  name: string;
  description: string;
  price: number;
  slots: number;
  created_at: string;
  updated_at: string;
  start_time: string; // date
  image: string;
  capacity: number;
  destination: Destination;
  bookings?: Booking[];
  has_booked?: Boolean;
}

export interface Destination {
  id: 1;
  name: string;
  slug: string;
  description: string;
  created_at: string; // date
  updated_at: string; // date
}

export type FetchStatus = "idle" | "pending" | "success" | "error";

export type ServerError = {
  message: string;
};

export type ServerValidationError = ServerError & {
  errors: Record<string, string[]>;
};

export type User = {
  name: string;
  role: "admin" | "user";
};

export interface Booking {
  id: string;
  tickets: Ticket[];
  user: User;
  user_id: string;
  status: "confirmed" | "pending" | "cancelled";
  tour: Tour;
}

export interface Ticket {
  id: string;
  ticket_number: string;
  created_at: string;
  booking_id: string;
  booking?: Booking;
}

export type ToursSearchQuery = {
  limit?: number;
  destination_id?: string;
  min_price?: number;
  max_price?: number;
  min_start_time?: string;
  min_end_time?: string;
  order_by?: string;
};
