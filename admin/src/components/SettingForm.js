import React from "react";
import {
  Box,
  Flex,
  IconButton,
  ButtonGroup,
  Input,
  Editable,
  EditableInput,
  EditablePreview,
  useEditableControls,
} from "@chakra-ui/react";
import { CheckIcon, EditIcon, CloseIcon } from "@chakra-ui/icons";

export default function SettingForm({ value, onSubmit, ...props }) {
  function EditableControls() {
    const {
      isEditing,
      getSubmitButtonProps,
      getCancelButtonProps,
      getEditButtonProps,
    } = useEditableControls();

    return isEditing ? (
      <ButtonGroup size="xs">
        <IconButton
          colorScheme="green"
          variant="outline"
          icon={<CheckIcon />}
          {...getSubmitButtonProps()}
        />
        <IconButton
          colorScheme="red"
          variant="ghost"
          icon={<CloseIcon />}
          {...getCancelButtonProps()}
        />
      </ButtonGroup>
    ) : (
      <ButtonGroup size="xs">
        <IconButton
          colorScheme="brand"
          variant="outline"
          icon={<EditIcon />}
          {...getEditButtonProps()}
        />
      </ButtonGroup>
    );
  }

  return (
    <Editable
      defaultValue={value}
      isPreviewFocusable={false}
      onSubmit={(value) => onSubmit(value)}
      {...props}
    >
      <Flex align="center">
        <Box mr={4}>
          <EditablePreview />
          <Input as={EditableInput} />
        </Box>
        <EditableControls />
      </Flex>
    </Editable>
  );
}
