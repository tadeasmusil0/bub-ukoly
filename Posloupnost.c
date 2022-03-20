#include <stdlib.h>
#include <stdio.h>
#include <math.h>

int main()
{   
    int n = 5;
    int a1 = 6;
    int d = 1;
    
    int pole[n];
    pole[0] = a1;
    printf("pole[0] = %i\n", a1);
    
    for(int x = 1; x < n; x++){
       pole[x] = a1 + d;
       a1 = a1 + d;
        printf("pole[%i] = %i\n", x, pole[x]);
    }
    
    return 0;
}