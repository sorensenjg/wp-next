import useSWR from "swr";
import axios from "axios";
import qs from "qs";
import { NEXT_API_URL } from "./constants";
import { startsWith } from "lodash";

axios.interceptors.request.use((config) => {
  config.headers["X-WP-Nonce"] = window.wpNext.nonce;
  return config;
});

const fetcher = (url) => axios.get(url).then((res) => res.data);

export default function useSettings(options = {}) {
  const { data, error, mutate } = useSWR(
    [NEXT_API_URL + "/settings"],
    fetcher,
    options
  );
  const loading = !error && !data;

  // const filtered = data ? data.filter((option) => option.startsWith("wp_next_"));

  return {
    data,
    loading,
    error,
    mutate,
  };
}

export const updateSetting = async (key, value) => {
  // window.jQuery.ajax({
  //   url: AJAX_BASE + `/record/${key}`,
  //   dataType: "json",
  //   method: "POST",
  //   data: JSON.stringify(post_data),
  //   beforeSend: (xhr) => {
  //     xhr.setRequestHeader("X-WP-Nonce", window.wpApiSettings.nonce);
  //   },
  //   success: (data) => {
  //     if (true === data) {
  //       const saved = state.saved;
  //       saved[key] = true;
  //       setState({ saved });

  //       // HACK to hide 'saved' checkmark
  //       setTimeout(() => {
  //         saved[key] = false;
  //         setState({ saved });
  //       }, 1200);
  //     }
  //   },
  // });

  try {
    const response = await axios.post(
      `${NEXT_API_URL}/setting/${key}`,
      JSON.stringify({
        key,
        value,
      }),
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );

    console.log(response);
  } catch (error) {
    console.log(error);
  }
};
