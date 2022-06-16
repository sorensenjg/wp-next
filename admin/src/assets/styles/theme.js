import { extendTheme } from "@chakra-ui/react";

const colors = {
  brand: {
    50: "#E5F1FF",
    100: "#B8D9FF",
    200: "#8AC0FF",
    300: "#5CA7FF",
    400: "#2E8EFF",
    500: "#0070F3",
    600: "#005ECC",
    700: "#004799",
    800: "#002F66",
    900: "#001833",
  },
};

const fonts = {
  heading: `'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif`,
  body: `'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif`,
};

export const theme = extendTheme({ colors, fonts });
