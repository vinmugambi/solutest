import type { H3Event } from "h3";
import { appendResponseHeader } from "h3";
import { ref } from "vue";
import type { ServerError, ServerValidationError } from "~/types";

type Status = "idle" | "pending" | "success" | "error";

export function useFormSubmit<T>(
  url: string,
  withCookie: boolean = false,
  h3Event?: H3Event
) {
  const status = ref<Status>("idle");
  const data = ref<T | null>(null);
  const errorMessage = ref<string | null>(null);
  const validationErrors = ref<string[]>([]);

  const submitForm = async (formData: object) => {
    // Reset state before submission
    errorMessage.value = null;
    validationErrors.value = [];
    data.value = null;
    status.value = "pending";

    var reqOptions = {
      method: "POST",
      credentials: "include",
      body: formData,
    };

    try {
      const {
        data: result,
        error,
        status: resultStatus,
      } = await useAsyncData("mountains", () =>
        withCookie && h3Event
          ? fetchWithCookie(h3Event, url, {
              ...reqOptions,
              credentials: "omit",
            })
          : $fetch(url, reqOptions as any)
      );

      status.value = resultStatus.value;

      console.log(status, url);

      if (resultStatus.value == "error") {
        if (error.value?.statusCode === 422) {
          let errors = Object.values(
            (error.value.data as ServerValidationError).errors
          ).flat();
          validationErrors.value = errors;
        } else {
          errorMessage.value =
            (error.value?.data as ServerError).message ||
            "An error occurred during submission.";
        }
      }
      if (resultStatus.value == "success") {
        data.value = result.value as any;
      }
    } catch (err: any) {
      errorMessage.value = err.message || "An unexpected error occurred.";
    }
  };

  return {
    status,
    data,
    errorMessage,
    validationErrors,
    submitForm,
  };
}

export const fetchWithCookie = async (
  event: H3Event,
  url: string,
  options: any
) => {
  console.log(options);
  /* Get the response from the server endpoint */
  const res = await $fetch.raw(url, options);
  /* Get the cookies from the response */
  const cookies = res.headers.getSetCookie();
  /* Attach each cookie to our incoming Request */
  for (const cookie of cookies) {
    appendResponseHeader(event, "set-cookie", cookie);
  }
  /* Return the data of the response */
  return res._data;
};
