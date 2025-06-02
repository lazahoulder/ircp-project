#!/bin/bash

# Make sure the script is executable
chmod +x run-tests-with-sail.sh

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
  echo "Docker is not running. Please start Docker and try again."
  exit 1
fi

# Start Sail in detached mode
echo "Starting Laravel Sail..."
./vendor/bin/sail up -d

# Wait for containers to be ready
echo "Waiting for containers to be ready..."
sleep 10

# Run the RegistrationTest
echo "Running RegistrationTest..."
./vendor/bin/sail test --filter=RegistrationTest

# Optional: Run all tests
# echo "Running all tests..."
# ./vendor/bin/sail test

# Keep containers running for further testing
echo ""
echo "Tests completed. Sail containers are still running."
echo "You can run more tests with: ./vendor/bin/sail test"
echo "When you're done, stop Sail with: ./vendor/bin/sail down"
