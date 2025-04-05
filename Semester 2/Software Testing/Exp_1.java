import java.util.*;

public class Exp_1 {

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        while (true) {
            System.out.println("Choose an operation:");
            System.out.println("A: Addition");
            System.out.println("S: Subtraction");
            System.out.println("M: Multiplication");
            System.out.println("D: Division");
            System.out.println("Q: Quit");

            System.out.print("Enter your choice: ");
            char choice = sc.next().toUpperCase().charAt(0);

            if (choice == 'Q') {
                System.out.println("Exiting the program. Goodbye!");
                break;
            }

            double num1 = 0, num2 = 0;
            boolean validInput = true;

            try {
                System.out.print("Enter the first number: ");
                num1 = sc.nextDouble();

                System.out.print("Enter the second number: ");
                num2 = sc.nextDouble();
            } catch (Exception e) {
                System.out.println("Error: Please enter valid numeric values.");
                sc.nextLine();
                validInput = false;
            }

            if (validInput) {
                switch (choice) {
                    case 'A':
                        System.out.println("Result: " + add(num1, num2));
                        break;
                    case 'S':
                        System.out.println("Result: " + subtract(num1, num2));
                        break;
                    case 'M':
                        System.out.println("Result: " + multiply(num1, num2));
                        break;
                    case 'D':
                        System.out.println("Result: " + divide(num1, num2));
                        break;
                    default:
                        System.out.println("Invalid choice. Please try again.");
                }
            }
            System.out.println();
        }
        sc.close();
    }

    public static double add(double a, double b) {
        return a + b;
    }

    public static double subtract(double a, double b) {
        return a - b;
    }

    static double multiply(double a, double b) {
        return a * b;
    }

    static String divide(double a, double b) {
        if (b == 0) {
            return "Error: Division by zero is not allowed.";
        }
        return String.valueOf(a / b);
    }
}


import java.math.BigDecimal;
import java.util.Scanner;

public class Exp_1 {

    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);

        while (true) {
            System.out.println("Choose an operation:");
            System.out.println("A: Addition");
            System.out.println("S: Subtraction");
            System.out.println("M: Multiplication");
            System.out.println("D: Division");
            System.out.println("Q: Quit");

            System.out.print("Enter your choice: ");
            String input = sc.nextLine().trim().toUpperCase();

            // Handle quitting
            if (input.equals("Q")) {
                System.out.println("Exiting the program. Goodbye!");
                break;
            }

            // Validate choice
            if (!"A".equals(input) && !"S".equals(input) && !"M".equals(input) && !"D".equals(input)) {
                System.out.println("Invalid choice. Please select a valid operation.");
                continue;
            }

            BigDecimal num1 = null, num2 = null;
            boolean validInput = true;

            // Input first and second numbers
            try {
                System.out.print("Enter the first number: ");
                num1 = new BigDecimal(sc.nextLine().trim());

                System.out.print("Enter the second number: ");
                num2 = new BigDecimal(sc.nextLine().trim());
            } catch (NumberFormatException e) {
                System.out.println("Error: Please enter valid numeric values.");
                validInput = false;
            }

            if (validInput) {
                switch (input) {
                    case "A":
                        System.out.println("Result: " + add(num1, num2));
                        break;
                    case "S":
                        System.out.println("Result: " + subtract(num1, num2));
                        break;
                    case "M":
                        System.out.println("Result: " + multiply(num1, num2));
                        break;
                    case "D":
                        System.out.println("Result: " + divide(num1, num2));
                        break;
                }
            }
            System.out.println();
        }

        sc.close();
    }

    // Addition using BigDecimal
    public static BigDecimal add(BigDecimal a, BigDecimal b) {
        return a.add(b);
    }

    // Subtraction using BigDecimal
    public static BigDecimal subtract(BigDecimal a, BigDecimal b) {
        return a.subtract(b);
    }

    // Multiplication using BigDecimal
    public static BigDecimal multiply(BigDecimal a, BigDecimal b) {
        return a.multiply(b);
    }

    // Division with zero check and scaling for precision
    public static String divide(BigDecimal a, BigDecimal b) {
        if (b.compareTo(BigDecimal.ZERO) == 0) {
            return "Error: Division by zero is not allowed.";
        }
        return a.divide(b, 10, BigDecimal.ROUND_HALF_UP).toString(); // Rounds to 10 decimal places
    }
}
