import React from "react";
import { ChakraProvider } from "@chakra-ui/react";
import Dashboard from "./components/Dashboard";
import { theme } from "./assets/styles/theme";

export default function App() {
  return (
    <ChakraProvider theme={theme}>
      <Dashboard />
    </ChakraProvider>
  );
}
