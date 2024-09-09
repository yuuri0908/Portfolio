import {
  FormControl,
  FormLabel,
  FormErrorMessage,
  FormHelperText,
  Input,
} from '@chakra-ui/react'




export default function UploadForm() {
  return(
    <FormControl>
      <FormLabel>Email address</FormLabel>
      <Input type='email' />
      <FormHelperText>We'll never share your email.</FormHelperText>
    </FormControl>
  )
}