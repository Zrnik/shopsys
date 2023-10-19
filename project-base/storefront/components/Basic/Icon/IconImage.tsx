import { HTMLAttributes } from 'react';
import { ExtractNativePropsFromDefault } from 'types/ExtractNativePropsFromDefault';

type NativeProps = ExtractNativePropsFromDefault<HTMLAttributes<HTMLElement>, never, 'onClick' | 'title'>;

type IconImageProps = NativeProps & {
    icon: string;
    alt: string | undefined;
    width?: number;
    height?: number;
};

export const IconImage: FC<IconImageProps> = ({ icon, height, width, ...props }) => {
    return (
        <img
            height={height !== undefined ? height : '24'}
            src={`/icons/${icon}.png`}
            width={width !== undefined ? width : '24'}
            {...props}
        />
    );
};
