import useSettings, { updateSetting } from "../lib/settings";
import {
  Box,
  Flex,
  Container,
  Heading,
  Text,
  Center,
  Spinner,
  List,
  ListItem,
  FormControl,
  FormLabel,
  FormHelperText,
} from "@chakra-ui/react";
import SettingForm from "./SettingForm";
import { KEY_NAME_MAP } from "../lib/constants";

export default function Dashboard() {
  const { data: settings, loading } = useSettings();
  console.log(settings);

  if (loading)
    return (
      <Center h="calc(100vh - 32px)">
        <Spinner size="xl" />
      </Center>
    );

  return (
    <Box>
      <Container maxW="full" px={2} py={12}>
        <Box>
          <Box maxW="520px" pb={4} borderBottomWidth={1}>
            <Heading>WordPress + Next</Heading>
            <Text fontSize="md">
              WordPress Next is a free open-source WordPress plugin that
              optimizes your WordPress site to work as a data source for NextJS.
            </Text>
          </Box>
          <List spacing={6} my={10}>
            {settings &&
              Object.keys(settings).map((key) => (
                <ListItem key={key}>
                  <FormControl>
                    <Flex align="center">
                      <FormLabel htmlFor={key} fontWeight="bold" mb={0}>
                        {KEY_NAME_MAP[key].label}
                      </FormLabel>
                      <SettingForm
                        id={key}
                        type="text"
                        colorScheme="brand"
                        fontSize="md"
                        value={settings[key]}
                        onSubmit={(value) => updateSetting(key, value)}
                      />
                    </Flex>
                    <FormHelperText>
                      {KEY_NAME_MAP[key].helpText}
                    </FormHelperText>
                  </FormControl>
                </ListItem>
              ))}
          </List>
        </Box>
      </Container>
    </Box>
  );
}
