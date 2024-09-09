import {
  FormControl,
  FormLabel,
  FormErrorMessage,
  FormHelperText,
  Input,
  Box,
  Text,
} from '@chakra-ui/react'




export default function UploadForm() {
  return(
    <div>
      <FormControl>
        <FormLabel>Email address</FormLabel>
        <Input type='email' />
        <FormHelperText>We'll never share your email.</FormHelperText>
      </FormControl>
      <Box>
        <Text>アップロード</Text>
      </Box>
    </div>
  )
}